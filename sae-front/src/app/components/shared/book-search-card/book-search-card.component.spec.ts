import { ComponentFixture, TestBed } from '@angular/core/testing';

import { BookSearchCardComponent } from './book-search-card.component';

describe('BookSearchCardComponent', () => {
  let component: BookSearchCardComponent;
  let fixture: ComponentFixture<BookSearchCardComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [BookSearchCardComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(BookSearchCardComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
