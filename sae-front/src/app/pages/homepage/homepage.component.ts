import { Component, OnInit } from '@angular/core';
import { BookSearchCardComponent } from '../../components/shared/book-search-card/book-search-card.component';
import { FormBuilder, FormGroup, ReactiveFormsModule, FormControl, AbstractControl, FormArray, FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-homepage',
  standalone: true,
  imports: [BookSearchCardComponent, ReactiveFormsModule, CommonModule, FormsModule],
  templateUrl: './homepage.component.html',
  styleUrl: './homepage.component.scss'
})
export class HomepageComponent implements OnInit {

  rechercheForm: FormGroup;
  searchBarValue = '';
  isSearchLaunched = true;


  // Fake datas
  auteurs = ['Auteur 1', 'Auteur 2', 'Auteur 3'];
  categories = ['Catégorie 1', 'Catégorie 2', 'Catégorie 3'];

  constructor(
    private fb: FormBuilder,
    private route: ActivatedRoute,
    private router: Router
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

    // Get routes param
    this.route.queryParams
      .subscribe(params => {
        console.log(params);
      }
      );

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


  }


  /**
   * Trigerred when user click on search button
   * Change URL and launch search
   */
  launchSearch() {
    this.router.navigate(['/search'], { queryParams: { keyword: this.searchBarValue, auteur: this.rechercheForm.value.auteur, dateMin: this.rechercheForm.value.dateMin, dateMax: this.rechercheForm.value.dateMax } });
    this.isSearchLaunched = true;
  }




}
