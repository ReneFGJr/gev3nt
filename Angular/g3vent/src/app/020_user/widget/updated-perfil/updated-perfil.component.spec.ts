import { ComponentFixture, TestBed } from '@angular/core/testing';

import { UpdatedPerfilComponent } from './updated-perfil.component';

describe('UpdatedPerfilComponent', () => {
  let component: UpdatedPerfilComponent;
  let fixture: ComponentFixture<UpdatedPerfilComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [UpdatedPerfilComponent]
    });
    fixture = TestBed.createComponent(UpdatedPerfilComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
