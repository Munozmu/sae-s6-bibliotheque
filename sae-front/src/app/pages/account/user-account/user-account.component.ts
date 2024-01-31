import { Component, OnInit } from '@angular/core';
import { BookCardSmallComponent } from '../../../components/shared/book-card-small/book-card-small.component';
import { CommonModule } from '@angular/common';
import { ActivatedRoute, Router, RouterModule } from '@angular/router';

@Component({
  selector: 'app-user-account',
  standalone: true,
  imports: [BookCardSmallComponent, CommonModule, RouterModule],
  templateUrl: './user-account.component.html',
  styleUrl: './user-account.component.scss',
})
export class UserAccountComponent implements OnInit {

  tabs = [
    { title: 'Profil', link: 'profile', isSelected: true },
    { title: 'Mes réservations', link: 'booking', isSelected: false },
  ];

  currentTab = 'profile';

  constructor(
    private route: ActivatedRoute,
    private router: Router
  ) { }

  ngOnInit(): void {

    // Add the param to url by default
    this.router.navigate(['/account'], { queryParams: { tab: 'profile' } });

    // Get tab param in the url
    this.route.queryParams.subscribe(params => {
      this.currentTab = params['tab'];
    });

  }

  changeTab(link: string): void {
    // add param to url
    this.router.navigate(['/account'], { queryParams: { tab: link } });
  }



}
