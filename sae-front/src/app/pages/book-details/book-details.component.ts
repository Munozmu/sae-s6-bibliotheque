import { Component } from '@angular/core';
import { AuthorInfosComponent } from '../../components/shared/author-infos/author-infos.component';

@Component({
  selector: 'app-book-details',
  standalone: true,
  imports: [AuthorInfosComponent],
  templateUrl: './book-details.component.html',
  styleUrl: './book-details.component.scss'
})
export class BookDetailsComponent {

}
