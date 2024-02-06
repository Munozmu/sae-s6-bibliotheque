import { Component, Input, OnInit } from '@angular/core';
import { RouterModule } from '@angular/router';
import { Book } from '../../../core/models/book';
import { BookStatus } from '../../../core/models/bookStatus';
import { BookService } from '../../../core/services/book.service';
import { CommonModule, DatePipe } from '@angular/common';

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
  ) { }


  ngOnInit(): void {

    this.bookService.getBookById(this.book.livreId || 0).subscribe(book => {
      this.bookService.getBookStatus(book).subscribe(status => {
        this.bookStatus = status;
        console.log('Bookstatus:', this.bookStatus);
      }
      );
    }
    );
  }

}


