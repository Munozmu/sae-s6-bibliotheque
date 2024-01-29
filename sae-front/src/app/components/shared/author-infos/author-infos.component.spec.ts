import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AuthorInfosComponent } from './author-infos.component';

describe('AuthorInfosComponent', () => {
  let component: AuthorInfosComponent;
  let fixture: ComponentFixture<AuthorInfosComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [AuthorInfosComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(AuthorInfosComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
