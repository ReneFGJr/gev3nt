import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EventProgrammerComponent } from './event-programmer.component';

describe('EventProgrammerComponent', () => {
  let component: EventProgrammerComponent;
  let fixture: ComponentFixture<EventProgrammerComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [EventProgrammerComponent]
    });
    fixture = TestBed.createComponent(EventProgrammerComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
