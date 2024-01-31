import { Component } from '@angular/core';
import { BookCardSmallComponent } from '../../../components/shared/book-card-small/book-card-small.component';

@Component({
  selector: 'app-user-account',
  standalone: true,
  imports: [BookCardSmallComponent],
  templateUrl: './user-account.component.html',
  styleUrl: './user-account.component.scss',
})
export class UserAccountComponent {}
