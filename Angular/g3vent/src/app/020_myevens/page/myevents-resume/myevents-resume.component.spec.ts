import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MyeventsResumeComponent } from './myevents-resume.component';

describe('MyeventsResumeComponent', () => {
  let component: MyeventsResumeComponent;
  let fixture: ComponentFixture<MyeventsResumeComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [MyeventsResumeComponent]
    });
    fixture = TestBed.createComponent(MyeventsResumeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
