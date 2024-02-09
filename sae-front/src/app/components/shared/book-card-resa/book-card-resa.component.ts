import { DatePipe } from '@angular/common';
import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { RouterModule } from '@angular/router';
import { BookService } from '../../../core/services/book.service';
import { ReservationsService } from '../../../core/services/reservations.service';
import { AuthService } from '../../../core/auth/auth.service';
import { BookStatus } from '../../../core/models/bookStatus';

@Component({
  selector: 'app-book-card-resa',
  standalone: true,
  imports: [RouterModule, DatePipe],
  templateUrl: './book-card-resa.component.html',
  styleUrl: './book-card-resa.component.scss'
})
export class BookCardResaComponent implements OnInit {

  @Input() title: string = '';
  @Input() id: number = 0;
  @Input() photoPath: string = '';
  @Input() dateResa: Date = new Date();


  bookStatus: BookStatus = {} as BookStatus;

  @Output() notifyParent: EventEmitter<any> = new EventEmitter();

  constructor(
    private bookService: BookService,
    private reservationService: ReservationsService,
    private authService: AuthService
  ) { }

  getExpirationDate(date: Date): number {
    // Crée une nouvelle date en ajoutant 7 jours à la date fournie
    const expirationDate = new Date(date);
    expirationDate.setDate(expirationDate.getDate() + 7);

    // Calcule la différence entre la date actuelle et la date d'expiration en millisecondes
    const difference = expirationDate.getTime() - new Date().getTime();

    // Convertit la différence en jours
    const daysRemaining = Math.ceil(difference / (1000 * 60 * 60 * 24));

    // Retourne une chaîne représentant le nombre de jours restant
    return daysRemaining;
  }

  ngOnInit(): void {

    this.refreshCurrentBookStatus();


  }

  refreshCurrentBookStatus() {
    this.bookService.getBookById(this.id || 0).subscribe(book => {
      this.bookService.getBookStatus(book).subscribe(status => {
        this.bookStatus = status;
      }
      );
    }
    );
  }

  cancelReservation() {
    this.reservationService.cancelReservation(this.bookStatus.reservationId || 0).subscribe(
      (res) => {
        console.log('Reservation cancelled:', res);
        this.refreshCurrentBookStatus();
      }
    );
    this.notifyParent.emit();
  }

  reserveBook() {
    this.reservationService.postReservation(this.id || 0, 1).subscribe(
      {
        next: (response) => {
          // Gérer la réponse réussie si nécessaire
          console.log('Réponse réussie : ', response);
          this.refreshCurrentBookStatus();
        },
        error: (error) => {
          // Gérer l'erreur ici
          console.error('Limite de réservation atteinte : ', error);
          if (error.status === 500) {
            alert('Vous avez atteint la limite de réservation. Vous ne pouvez réserver que 3 livres à la fois.');
          }
        }
      });

  }



}
