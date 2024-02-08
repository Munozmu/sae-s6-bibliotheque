import { Component, Input, OnInit } from '@angular/core';
import { Book } from '../../../core/models/book';
import { CommonModule, DatePipe } from '@angular/common';

@Component({
  selector: 'app-book-card-small',
  standalone: true,
  imports: [CommonModule, DatePipe],
  templateUrl: './book-card-small.component.html',
  styleUrl: './book-card-small.component.scss',
})
export class BookCardSmallComponent {
  @Input() book: Book = {} as Book;
  @Input() isReserved: boolean = false;
  @Input() isDisabled: boolean = false;
  @Input() isEmprunt: boolean = false;
}
