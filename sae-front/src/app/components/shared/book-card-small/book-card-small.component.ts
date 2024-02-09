import { Component, Input, OnInit } from '@angular/core';
import { Book } from '../../../core/models/book';
import { CommonModule, DatePipe } from '@angular/common';
import { RouterModule } from '@angular/router';
import { BookStatus } from '../../../core/models/bookStatus';
import { BookService } from '../../../core/services/book.service';
import { ReservationsService } from '../../../core/services/reservations.service';
import { AuthService } from '../../../core/auth/auth.service';


@Component({
  selector: 'app-book-card-small',
  standalone: true,
  imports: [DatePipe, RouterModule, CommonModule],
  templateUrl: './book-card-small.component.html',
  styleUrl: './book-card-small.component.scss',
})
export class BookCardSmallComponent {
  @Input() book: Book = {} as Book;

  bookStatus: BookStatus = {} as BookStatus;

  isLoggedIn = false;

  constructor(
    private bookService: BookService,
    private reservationService: ReservationsService,
    private authService: AuthService
  ) { }

  ngOnInit(): void {

    this.refreshCurrentBookStatus();

    this.isLoggedIn = this.authService.isLoggedIn();


  }

  refreshCurrentBookStatus() {
    this.bookService.getBookById(this.book.id || 0).subscribe(book => {
      this.bookService.getBookStatus(book).subscribe(status => {
        this.bookStatus = status;
      }
      );
    }
    );
  }

  cancelReservation() {
    this.reservationService.cancelReservation(this.bookStatus.reservationId || 0).subscribe(
      (res) => {
        console.log('Reservation cancelled:', res);
        this.refreshCurrentBookStatus();
      }
    );
  }

  reserveBook() {
    this.reservationService.postReservation(this.book.id || 0, 1).subscribe(
      {
        next: (response) => {
          // Gérer la réponse réussie si nécessaire
          console.log('Réponse réussie : ', response);
          this.refreshCurrentBookStatus();
        },
        error: (error) => {
          // Gérer l'erreur ici
          console.error('Limite de réservation atteinte : ', error);
          alert('Vous avez atteint la limite de réservation. Vous ne pouvez réserver que 3 livres à la fois.');
        }
      });

  }
}
