import { Component, OnInit } from '@angular/core';
import { BookService } from '../../core/services/book.service';
import { BookCardSmallComponent } from '../../components/shared/book-card-small/book-card-small.component';
import { Book } from '../../core/models/book';
import { CommonModule } from '@angular/common';
import { Categories } from '../../core/models/categories';
import { CategoriesService } from '../../core/services/categories.service';
import { ActivatedRoute, Router, RouterModule } from '@angular/router';
import { first } from 'rxjs';

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
  currentPagination: number = 1;

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
    this.getAllBooks();

    // Get all categories
    this.categorieService.getAllCategories().subscribe((categories) => {
      this.categories = categories;
    });

    this.route.queryParams.pipe(first()).subscribe(params => {
      if (params['category']) {
        this.isSelectedCat = true;
        this.getBooksByCategory(params['category']);
      } else {
        this.isSelectedCat = false;
        this.getAllBooks();
      }
    });

  }

  selectCategory(category: number) {
    this.router.navigate(['/catalog'], { queryParams: { category: category } });
    this.isSelectedCat = false;
    this.getBooksByCategory(category);
  }

  getAllBooks() {
    this.books = [];
    this.bookService.getAllBooks().subscribe((books) => {
      this.books = books;
    });
    this.isSelectedCat = false;
  }

  getBooksByCategory(category: number) {
    this.router.navigate(['/catalog'], { queryParams: { category: category } });
    this.categorieService.getCategory(category).subscribe((cat) => {
      this.books = [];
      this.books = cat.livres ? cat.livres : [];
      this.currentCategory = cat;
    });
    this.isSelectedCat = true;
  }

  paginationPlus() {
    this.currentPagination++;
    this.bookService.getAllBooks(this.currentPagination).subscribe((books) => {
      this.books = books;
    });

  }

  paginationMinus() {
    if (this.currentPagination > 1) {
      this.currentPagination--;
      this.bookService.getAllBooks(this.currentPagination).subscribe((books) => {
        this.books = books;
      });
    }
  }


}
