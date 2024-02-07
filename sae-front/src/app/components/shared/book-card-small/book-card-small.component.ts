import { Component, Input, OnInit } from '@angular/core';
import { Book } from '../../../core/models/book';
import { DatePipe } from '@angular/common';
import { RouterModule } from '@angular/router';
import { BookStatus } from '../../../core/models/bookStatus';
import { BookService } from '../../../core/services/book.service';

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
  ) { }

  ngOnInit(): void {

    this.bookService.getBookById(this.book.id || 0).subscribe(book => {
      this.bookService.getBookStatus(book).subscribe(status => {
        this.bookStatus = status;
        console.log('Bookstatus:', this.bookStatus);
      }
      );
    }
    );
  }

}
