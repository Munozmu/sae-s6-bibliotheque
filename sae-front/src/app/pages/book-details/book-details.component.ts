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

  constructor(
    private bookService: BookService,
    private route: ActivatedRoute,
    private router: Router,
    private authService: AuthService,
    private reservationService: ReservationsService
  ) { }

  currentUser$ = this.authService.currentUser$;

  ngOnInit(): void {

    // Get the last segment of the URL (the book ID)
    const bookId = parseInt(this.route.snapshot.paramMap.get('id') || '0');

    // Check if the user is logged
    this.isUserLogged = this.authService.isLoggedIn();

    this.bookService.getBookById(bookId)
      .pipe(
        catchError((error) => {
          // Check if the error status is 404
          if (error.status === 404) {
            // Redirect to the home page or any other page as needed
            this.router.navigate(['/']);
            // You can also return an observable to replace the original one
            return of(null); // or any other observable
          } else {
            // If it's not a 404 error, re-throw the error
            throw error;
          }
        })
      )
      .subscribe((book: Book | null) => {
        // Check if book is not null to avoid errors if you decide to return an observable in catchError
        if (book) {
          this.currentBook = book;

          // -------
          // Disabled the button if the book is already borrowed or reserved
          // -------

          // Si il y a un emprunt
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
