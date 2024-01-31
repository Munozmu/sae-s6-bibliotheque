import { Component, OnInit } from '@angular/core';
import { AuthorInfosComponent } from '../../components/shared/author-infos/author-infos.component';
import { BookCardSmallComponent } from '../../components/shared/book-card-small/book-card-small.component';
import { ActivatedRoute, Route, Router, RouterModule } from '@angular/router';
import { BookService } from '../../core/services/book.service';
import { Book } from '../../core/models/book';
import { catchError, of } from 'rxjs';
import { CommonModule, DatePipe } from '@angular/common';

@Component({
  selector: 'app-book-details',
  standalone: true,
  imports: [AuthorInfosComponent, BookCardSmallComponent, RouterModule, DatePipe, CommonModule],
  templateUrl: './book-details.component.html',
  styleUrl: './book-details.component.scss'
})
export class BookDetailsComponent implements OnInit {

  currentBook: Book = {} as Book;

  constructor(
    private bookService: BookService,
    private route: ActivatedRoute,
    private router: Router
  ) { }

  ngOnInit(): void {

    // Get the last segment of the URL (the book ID)
    const bookId = parseInt(this.route.snapshot.paramMap.get('id') || '0');

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
        if (book !== null) {
          this.currentBook = book;
        }
      });
  }

}
