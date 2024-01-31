import { Component } from '@angular/core';
import { AuthorInfosComponent } from '../../components/shared/author-infos/author-infos.component';
import { BookCardSmallComponent } from '../../components/shared/book-card-small/book-card-small.component';
import { RouterModule } from '@angular/router';

@Component({
  selector: 'app-book-details',
  standalone: true,
  imports: [AuthorInfosComponent, BookCardSmallComponent, RouterModule],
  templateUrl: './book-details.component.html',
  styleUrl: './book-details.component.scss'
})
export class BookDetailsComponent {

}
