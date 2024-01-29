import { Component } from '@angular/core';
import { BookSearchCardComponent } from '../../components/shared/book-search-card/book-search-card.component';

@Component({
  selector: 'app-homepage',
  standalone: true,
  imports: [BookSearchCardComponent],
  templateUrl: './homepage.component.html',
  styleUrl: './homepage.component.scss'
})
export class HomepageComponent {

}
