import { Routes } from '@angular/router';
import { HomepageComponent } from './pages/homepage/homepage.component';
import { BookDetailsComponent } from './pages/book-details/book-details.component';
import { UserAccountComponent } from './pages/account/user-account/user-account.component';

export const routes: Routes = [
  { path: '', component: HomepageComponent },
  { path: 'account', component: UserAccountComponent },
  { path: 'book/:id', component: BookDetailsComponent },
];
