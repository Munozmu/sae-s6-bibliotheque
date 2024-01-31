import { Component, OnInit } from '@angular/core';
import { BookService } from '../../core/services/book.service';
import { BookCardSmallComponent } from '../../components/shared/book-card-small/book-card-small.component';
import { Book } from '../../core/models/book';
import { CommonModule } from '@angular/common';
import { Categories } from '../../core/models/categories';
import { CategoriesService } from '../../core/services/categories.service';
import { ActivatedRoute, Router, RouterModule } from '@angular/router';

@Component({
  selector: 'app-catalog',
  standalone: true,
  imports: [BookCardSmallComponent, CommonModule, RouterModule],
  templateUrl: './catalog.component.html',
  styleUrl: './catalog.component.scss'
})
export class CatalogComponent implements OnInit {

  books: Book[] = [];
  categories: Categories[] = [];

  isSelectedCat: boolean = false;

  currentCategory: Categories = {} as Categories;

  constructor(
    private bookService: BookService,
    private categorieService: CategoriesService,
    private route: ActivatedRoute,
    private router: Router
  ) { }

  ngOnInit(): void {

    // Get all books
    // Get all books
    this.bookService.getAllBooks().subscribe((books) => {
      this.books = books;
    });

    // Get all categories
    this.categorieService.getAllCategories().subscribe((categories) => {
      this.categories = categories;
    });

    // Check URL params
    this.route.queryParams.subscribe(params => {
      if (params['category']) {
        this.categorieService.getCategory(params['category']).subscribe((cat) => {
          this.books = cat.livres ? cat.livres : [];
          this.currentCategory = cat;
        });
        this.isSelectedCat = true;

      }
      else {
        // Get all books
        this.bookService.getAllBooks().subscribe((books) => {
          this.books = books;
        });
      }
    });

  }


}
