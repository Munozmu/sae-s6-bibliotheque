import { Component, OnInit } from '@angular/core';
import { BookSearchCardComponent } from '../../components/shared/book-search-card/book-search-card.component';
import { BookService } from '../../core/services/book.service';
import { FormBuilder, FormGroup, ReactiveFormsModule, FormControl, AbstractControl, FormArray } from '@angular/forms';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-homepage',
  standalone: true,
  imports: [BookSearchCardComponent, ReactiveFormsModule, CommonModule],
  templateUrl: './homepage.component.html',
  styleUrl: './homepage.component.scss'
})
export class HomepageComponent implements OnInit {

  filtreForm: FormGroup;

  constructor(
    private bookService: BookService,
    private formBuilder: FormBuilder
  ) {
    this.filtreForm = this.formBuilder.group({
      anneeMin: [''],
      anneeMax: [''],
      categorie: ['tous'],
      auteurs: this.formBuilder.array([])
    });
  }

  auteurs = [
    { id: 1, nom: 'Hugo' },
    { id: 2, nom: 'Zola' },
    { id: 3, nom: 'Maupassant' },
  ]


  ngOnInit(): void {
    this.bookService.getAllBooks().subscribe((books) => {
      console.log(books);
    }
    );
    this.filtreForm.valueChanges.subscribe(() => {
      console.log(this.filtreForm.value);
    });

    // Ajouter les auteurs dans le formulaire
    this.auteurs.forEach((auteur, i) => {
      let group = this.formBuilder.group({});
      group.addControl(this.auteurs[i].nom, this.formBuilder.control(false));
      this.formArr.push(group);
    });
  }

  get formArr() {
    return this.filtreForm.get('auteurs') as FormArray;
  }

  refreshSearch() {
    console.log("refreshSearch");
  }
}
