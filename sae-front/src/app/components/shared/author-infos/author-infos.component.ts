import { Component, Input, OnInit } from '@angular/core';
import { Author } from '../../../core/models/author';

@Component({
  selector: 'app-author-infos',
  standalone: true,
  imports: [],
  templateUrl: './author-infos.component.html',
  styleUrl: './author-infos.component.scss'
})
export class AuthorInfosComponent implements OnInit {

  @Input() author: Author = {} as Author;

  constructor() { }

  ngOnInit(): void {
  }

}
