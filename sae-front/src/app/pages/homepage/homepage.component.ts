import { Component, OnInit } from '@angular/core';
import { BookSearchCardComponent } from '../../components/shared/book-search-card/book-search-card.component';
import { BookService } from '../../core/services/book.service';
import { FormBuilder, FormGroup, ReactiveFormsModule, FormControl, AbstractControl, FormArray } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { Author } from '../../core/models/author';

@Component({
  selector: 'app-homepage',
  standalone: true,
  imports: [BookSearchCardComponent, ReactiveFormsModule, CommonModule],
  templateUrl: './homepage.component.html',
  styleUrl: './homepage.component.scss'
})
export class HomepageComponent implements OnInit {

  rechercheForm: FormGroup;


  // Exemple de données d'auteurs (vous pouvez remplacer par les auteurs réels de votre application)
  auteurs = ['Auteur 1', 'Auteur 2', 'Auteur 3'];

  constructor(private fb: FormBuilder) {
    // Initialisation du formulaire avec les champs et les validateurs
    this.rechercheForm = this.fb.group({
      titre: [''],
      auteur: [''],
      dateMin: [''],
      dateMax: ['']
    });
  }

  ngOnInit(): void {
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
