import { Routes } from '@angular/router';
import { HomepageComponent } from './pages/homepage/homepage.component';
import { BookDetailsComponent } from './pages/book-details/book-details.component';

export const routes: Routes = [
  { path: '', component: HomepageComponent },
  { path: 'book/:id', component: BookDetailsComponent },
];
