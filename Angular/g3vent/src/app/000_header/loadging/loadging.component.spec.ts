import { ComponentFixture, TestBed } from '@angular/core/testing';

import { LoadgingComponent } from './loadging.component';

describe('LoadgingComponent', () => {
  let component: LoadgingComponent;
  let fixture: ComponentFixture<LoadgingComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [LoadgingComponent]
    });
    fixture = TestBed.createComponent(LoadgingComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
