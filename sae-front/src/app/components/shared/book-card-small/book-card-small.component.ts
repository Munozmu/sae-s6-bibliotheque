import { Component, Input, OnInit } from '@angular/core';
import { Book } from '../../../core/models/book';
import { DatePipe } from '@angular/common';
import { RouterModule } from '@angular/router';
import { BookStatus } from '../../../core/models/bookStatus';
import { BookService } from '../../../core/services/book.service';
import { ReservationsService } from '../../../core/services/reservations.service';

@Component({
  selector: 'app-book-card-small',
  standalone: true,
  imports: [DatePipe, RouterModule],
  templateUrl: './book-card-small.component.html',
  styleUrl: './book-card-small.component.scss'
})
export class BookCardSmallComponent {

  @Input() book: Book = {} as Book;

  bookStatus: BookStatus = {} as BookStatus;

  constructor(
    private bookService: BookService,
    private reservationService: ReservationsService,
  ) { }

  ngOnInit(): void {

    this.refreshCurrentBookStatus();

  }

  refreshCurrentBookStatus() {
    this.bookService.getBookById(this.book.id || 0).subscribe(book => {
      this.bookService.getBookStatus(book).subscribe(status => {
        this.bookStatus = status;
        console.log('Bookstatus:', this.bookStatus);
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
      (res) => {
        console.log('Reservation done:', res);
        this.refreshCurrentBookStatus();
      }
    );
  }

}
