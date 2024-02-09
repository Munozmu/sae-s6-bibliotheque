import { Component, OnInit } from '@angular/core';
import { AuthorInfosComponent } from '../../components/shared/author-infos/author-infos.component';
import { BookCardSmallComponent } from '../../components/shared/book-card-small/book-card-small.component';
import { ActivatedRoute, Route, Router, RouterModule } from '@angular/router';
import { BookService } from '../../core/services/book.service';
import { Book } from '../../core/models/book';
import { catchError, of } from 'rxjs';
import { CommonModule, DatePipe } from '@angular/common';
import { AuthService } from '../../core/auth/auth.service';
import { ReservationsService } from '../../core/services/reservations.service';
import { AuthorService } from '../../core/services/author.service';

@Component({
  selector: 'app-book-details',
  standalone: true,
  imports: [AuthorInfosComponent, BookCardSmallComponent, RouterModule, DatePipe, CommonModule],
  templateUrl: './book-details.component.html',
  styleUrl: './book-details.component.scss'
})
export class BookDetailsComponent implements OnInit {

  currentBook: Book = {} as Book;

  isBookReserved = true;
  isBookBorrowed = true;
  isUserLogged = false;

  authorBooks: Book[] = [];

  constructor(
    private bookService: BookService,
    private route: ActivatedRoute,
    private router: Router,
    private authService: AuthService,
    private reservationService: ReservationsService,
    private authorService: AuthorService
  ) { }

  currentUser$ = this.authService.currentUser$;

  ngOnInit(): void {

    // Get the last segment of the URL (the book ID)
    const bookId = parseInt(this.route.snapshot.paramMap.get('id') || '0');

    // Get author books


    // Check if the user is logged
    this.isUserLogged = this.authService.isLoggedIn();

    this.bookService.getBookById(bookId)
      .pipe(
        catchError((error) => {
          // Vérifie si le statut d'erreur est 404
          if (error.status === 404) {
            // Redirige vers la page d'accueil ou toute autre page nécessaire
            this.router.navigate(['/']);
            // Vous pouvez également renvoyer un observable pour remplacer l'observable d'origine
            return of(null); // ou tout autre observable
          } else {
            // S'il ne s'agit pas d'une erreur 404, rejeter l'erreur
            throw error;
          }
        })
      )
      .subscribe((book: Book | null) => {
        // Vérifie si le livre n'est pas nul pour éviter les erreurs si vous décidez de retourner un observable dans catchError
        if (book) {
          this.currentBook = book;

          // Appel au service de l'auteur après avoir récupéré le livre
          this.authorService.getAuthorById(this.currentBook.auteurs[0].id).subscribe((author) => {
            if (author) {
              this.authorBooks = author.livres;
              console.log(this.authorBooks);
            }
          });

          // -------
          // Désactive le bouton si le livre est déjà emprunté ou réservé
          // -------

          // S'il y a un emprunt
          if (this.currentBook.emprunts) {
            const emprunts = this.currentBook.emprunts as any[];
            if (emprunts.length === 0 || !emprunts[emprunts.length - 1].enCours) {
              this.isBookBorrowed = false;
            } else {
              this.isBookBorrowed = true;
            }
          } else {
            this.isBookBorrowed = false;
          }

          if (this.currentBook.reservations) {
            if (this.currentBook.reservations.length === 0) {
              this.isBookReserved = false;
            } else {
              this.isBookReserved = true;
            }
          } else {
            this.isBookReserved = false;
          }


          console.log(this.isBookBorrowed);
          console.log(this.isBookReserved);
        }

      });

  }


  makeReservation() {
    // Get the user ID from the current user

    this.authService.currentUser$.subscribe((user) => {
      if (user) {
        const userId = user.id;

        // Get the book ID from the current book
        const bookId = this.currentBook.id || 0;

        // Call the service to make the reservation
        this.reservationService.postReservation(bookId, userId).subscribe(() => {
          // Refresh the page to update the book status
          this.router.navigate([`/book/${bookId}`]);
        });
      }
    }
    );


  }

}
