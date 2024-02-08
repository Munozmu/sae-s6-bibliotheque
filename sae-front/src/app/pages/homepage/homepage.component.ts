import { Component, OnInit } from '@angular/core';
import { BookSearchCardComponent } from '../../components/shared/book-search-card/book-search-card.component';
import { FormBuilder, FormGroup, ReactiveFormsModule, FormControl, AbstractControl, FormArray, FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { ActivatedRoute, Router, RouterModule } from '@angular/router';
import { AuthorService } from '../../core/services/author.service';
import { Author } from '../../core/models/author';
import { CategoriesService } from '../../core/services/categories.service';
import { AuthService } from '../../core/auth/auth.service';
import { SearchEngineService } from '../../core/services/search-engine.service';
import { Book } from '../../core/models/book';

@Component({
  selector: 'app-homepage',
  standalone: true,
  imports: [BookSearchCardComponent, ReactiveFormsModule, CommonModule, FormsModule, RouterModule],
  templateUrl: './homepage.component.html',
  styleUrl: './homepage.component.scss'
})
export class HomepageComponent implements OnInit {

  rechercheForm: FormGroup;
  searchBarValue = '';

  searchResults: Book[] = [];


  // Fake datas
  auteurs: string[] = [];
  categories: string[] = [];

  constructor(
    private authorService: AuthorService,
    private authService: AuthService,
    private categorieService: CategoriesService,
    private fb: FormBuilder,
    private route: ActivatedRoute,
    private router: Router,
    private searchEngineService: SearchEngineService
  ) {
    // Init form
    this.rechercheForm = this.fb.group({
      titre: [''],
      auteur: [''],
      dateMin: ['1950'],
      dateMax: ['2024'],
      categorie: ['']
    });
  }

  ngOnInit(): void {



    // DEV ONLY : Connect user
    this.authService.login({ username: 'loic@gmail.com', password: 'loic' });

    // Get routes param and actualize form values
    this.route.queryParams
      .subscribe(params => {
        this.searchBarValue = params['keyword'];
        this.rechercheForm.patchValue({
          titre: params['keyword'],
          auteur: params['auteur'],
          dateMin: params['dateMin'],
          dateMax: params['dateMax']
        });
      }
      );

    // Get routes param
    this.route.queryParams
      .subscribe(params => {
        console.log(params);
        this.refreshSearch();
      }
      );

    // Get all authors
    this.authorService.getAllAuthors().subscribe(
      auteurs => {
        this.auteurs = auteurs.map(auteur => auteur.nom + ' ' + auteur.prenom);
      }
    );

    // Get all categories
    this.categorieService.getAllCategories().subscribe(
      categories => {
        this.categories = categories.map(categorie => categorie.nom);
      }
    );

  }


  /**
   * Trigerred when user click on search button
   * Change URL and launch search
   */
  launchSearch() {

    this.router.navigate(['/search'], {
      queryParams: {
        keyword: this.searchBarValue ? this.searchBarValue : '',
        auteur: this.rechercheForm.value.auteur,
        dateMin: this.rechercheForm.value.dateMin,
        dateMax: this.rechercheForm.value.dateMax
      }
    });

    this.refreshSearch();

  }

  refreshSearch() {
    this.resetSearch();
    this.searchEngineService.searchBooks(
      this.searchBarValue,
      this.rechercheForm.value.categorie,
      this.rechercheForm.value.auteur ? this.rechercheForm.value.auteur.split(' ')[0] : '',
      '',
      this.rechercheForm.value.dateMin,
      this.rechercheForm.value.dateMax
    ).subscribe(
      books => {
        console.log(books);
        this.searchResults = books;
      }
    )
  }

  resetSearch() {
    this.searchResults = [];
  }




}
