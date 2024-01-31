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
  isSearchLaunched = false;


  // Exemple de données d'auteurs (vous pouvez remplacer par les auteurs réels de votre application)
  auteurs = ['Auteur 1', 'Auteur 2', 'Auteur 3'];

  constructor(private fb: FormBuilder, private route: ActivatedRoute, private router: Router) {
    // Initialisation du formulaire avec les champs et les validateurs
    this.rechercheForm = this.fb.group({
      titre: [''],
      auteur: [''],
      dateMin: [''],
      dateMax: ['']
    });
  }

  ngOnInit(): void {

    // Get routes param
    this.route.queryParams
      .subscribe(params => {
        console.log(params);
      }
      );

  }


  launchSearch() {
    this.router.navigate(['/search'], { queryParams: { keyword: this.searchBarValue, auteur: this.rechercheForm.value.auteur, dateMin: this.rechercheForm.value.dateMin, dateMax: this.rechercheForm.value.dateMax } });
    this.isSearchLaunched = true;
  }

  // Méthode déclenchée lors de la soumission du formulaire de recherche
  rechercherLivres(): void {
    // Accéder aux valeurs du formulaire
    const values = this.rechercheForm.value;

    // Ici, vous pouvez implémenter la logique de recherche en utilisant les filtres
    // (par exemple, appeler un service pour obtenir les résultats de la recherche)
    console.log('Titre:', values.titre);
    console.log('Auteur:', values.auteur);
    console.log('Date Min:', values.dateMin);
    console.log('Date Max:', values.dateMax);
  }




}
