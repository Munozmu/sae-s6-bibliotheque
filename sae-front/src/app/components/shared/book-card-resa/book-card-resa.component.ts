import { Component, Input } from '@angular/core';
import { RouterModule } from '@angular/router';

@Component({
  selector: 'app-book-card-resa',
  standalone: true,
  imports: [RouterModule],
  templateUrl: './book-card-resa.component.html',
  styleUrl: './book-card-resa.component.scss'
})
export class BookCardResaComponent {

  @Input() title: string = '';
  @Input() id: number = 0;
  @Input() photoPath: string = '';

}
