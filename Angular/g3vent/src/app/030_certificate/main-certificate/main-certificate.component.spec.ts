import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MainCertificateComponent } from './main-certificate.component';

describe('MainCertificateComponent', () => {
  let component: MainCertificateComponent;
  let fixture: ComponentFixture<MainCertificateComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [MainCertificateComponent]
    });
    fixture = TestBed.createComponent(MainCertificateComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
