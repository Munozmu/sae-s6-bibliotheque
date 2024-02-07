import { Component, Input, OnInit } from '@angular/core';
import { RouterModule } from '@angular/router';
import { Book } from '../../../core/models/book';
import { BookStatus } from '../../../core/models/bookStatus';
import { BookService } from '../../../core/services/book.service';
import { CommonModule, DatePipe } from '@angular/common';
import { ReservationsService } from '../../../core/services/reservations.service';

@Component({
  selector: 'app-book-search-card',
  standalone: true,
  imports: [RouterModule, DatePipe, CommonModule],
  templateUrl: './book-search-card.component.html',
  styleUrl: './book-search-card.component.scss'
})
export class BookSearchCardComponent implements OnInit {

  @Input() book: Book = {} as Book;

  bookStatus: BookStatus = {} as BookStatus;

  constructor(
    private bookService: BookService,
    protected reservationService: ReservationsService,
  ) { }


  ngOnInit(): void {

    this.refreshCurrentBookStatus();

  }

  cancelReservation() {
    this.reservationService.cancelReservation(this.bookStatus.reservationId || 0).subscribe(
      (res) => {
        console.log('Reservation cancelled:', res);
        this.refreshCurrentBookStatus();
      }
    );
  }

  refreshCurrentBookStatus() {
    this.bookService.getBookById(this.book.livreId || 0).subscribe(book => {
      this.bookService.getBookStatus(book).subscribe(status => {
        this.bookStatus = status;
        console.log('Bookstatus:', this.bookStatus);
      }
      );
    }
    );
  }

  reserveBook() {
    this.reservationService.postReservation(this.book.livreId || 0, 1).subscribe(
      (res) => {
        console.log('Reservation done:', res);
        this.refreshCurrentBookStatus();
      }
    );
  }

}


