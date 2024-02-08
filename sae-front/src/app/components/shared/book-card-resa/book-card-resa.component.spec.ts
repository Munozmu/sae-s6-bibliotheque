import { ComponentFixture, TestBed } from '@angular/core/testing';

import { BookCardResaComponent } from './book-card-resa.component';

describe('BookCardResaComponent', () => {
  let component: BookCardResaComponent;
  let fixture: ComponentFixture<BookCardResaComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [BookCardResaComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(BookCardResaComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
