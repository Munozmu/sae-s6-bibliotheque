import { Routes } from '@angular/router';
import { HomepageComponent } from './pages/homepage/homepage.component';
import { BookDetailsComponent } from './pages/book-details/book-details.component';
import { CatalogComponent } from './pages/catalog/catalog.component';

export const routes: Routes = [
  { path: '', component: HomepageComponent },
  { path: 'search', component: HomepageComponent },
  { path: 'catalog', component: CatalogComponent },
  { path: 'book/:id', component: BookDetailsComponent },
];
