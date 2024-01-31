import { Component, Input, OnInit } from '@angular/core';
import { Author } from '../../../core/models/author';
import { DatePipe } from '@angular/common';
import { AuthorService } from '../../../core/services/author.service';

@Component({
  selector: 'app-author-infos',
  standalone: true,
  imports: [DatePipe],
  templateUrl: './author-infos.component.html',
  styleUrl: './author-infos.component.scss'
})
export class AuthorInfosComponent implements OnInit {

  @Input() authorId: number = {} as number;

  author: Author = {} as Author;

  constructor(
    private authorService: AuthorService
  ) { }

  ngOnInit(): void {
    this.authorService.getAuthorById(this.authorId)
      .subscribe((author: Author | null) => {
        if (author !== null) {
          this.author = author;
        }
      });
  }

}
