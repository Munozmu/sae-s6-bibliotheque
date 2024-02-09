import { Component, OnInit } from '@angular/core';
import { BookCardSmallComponent } from '../../../components/shared/book-card-small/book-card-small.component';
import { CommonModule, DatePipe } from '@angular/common';
import { ActivatedRoute, Router, RouterModule } from '@angular/router';
import { Adherent } from '../../../core/models/adherent';
import { AuthService } from '../../../core/auth/auth.service';
import { AbstractControl, FormBuilder, FormGroup, FormsModule, ReactiveFormsModule, Validators } from '@angular/forms';
import { AdherentService } from '../../../core/services/adherent.service';
import { BookCardResaComponent } from '../../../components/shared/book-card-resa/book-card-resa.component';

@Component({
  selector: 'app-user-account',
  standalone: true,
  imports: [BookCardSmallComponent, CommonModule, RouterModule, DatePipe, FormsModule, ReactiveFormsModule, BookCardResaComponent],
  templateUrl: './user-account.component.html',
  styleUrl: './user-account.component.scss',
})
export class UserAccountComponent implements OnInit {

  tabs = [
    { title: 'Profil', link: 'profile', isSelected: true },
    { title: 'Mes réservations', link: 'booking', isSelected: false },
  ];

  currentTab = 'profile';

  editProfileForm: FormGroup = {} as FormGroup;

  confirmMessage = '';


  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private authService: AuthService,
    private fb: FormBuilder,
    private adherentService: AdherentService
  ) {
  }

  get formControlEditProfile(): { [key: string]: AbstractControl } {
    return this.editProfileForm.controls;
  }

  currentUser$ = this.authService.currentUser$;

  ngOnInit(): void {

    // Add the param to url by default
    this.router.navigate(['/account'], { queryParams: { tab: 'profile' } });

    // Get tab param in the url
    this.route.queryParams.subscribe(params => {
      this.currentTab = params['tab'];
      this.refreshReservation();
    });

    // Get user
    this.currentUser$.subscribe(
      (user) => {
        if (user) {
          this.editProfileForm = this.fb.group({
            id: [user.id],
            prenom: [user.prenom, [Validators.required]],
            nom: [user.nom, [Validators.required]],
            numTel: [user.numTel, [Validators.required, Validators.pattern(/^\d{10}$/)]],
            dateNaiss: [user.dateNaiss, [Validators.required]],
            adressePostale: [user.adressePostale, [Validators.required]],
            email: [user.email, [Validators.required, Validators.email]],
          });
        }
      }
    );

  }

  refreshReservation() {
    this.authService.refreshCurrentUser();
  }

  changeTab(link: string): void {
    // add param to url
    this.router.navigate(['/account'], { queryParams: { tab: link } });
  }

  onSubmitEditProfile(): void {
    this.adherentService.updateAdherent(this.editProfileForm.value).subscribe(
      () => {
        this.confirmMessage = 'Profil mis à jour !';
        this.authService.refreshCurrentUser();
      },
      (error) => {
        console.error('Error updating adherent:', error);
      }
    );
  }



}
