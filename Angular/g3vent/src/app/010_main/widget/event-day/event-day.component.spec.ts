import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EventDayComponent } from './event-day.component';

describe('EventDayComponent', () => {
  let component: EventDayComponent;
  let fixture: ComponentFixture<EventDayComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [EventDayComponent]
    });
    fixture = TestBed.createComponent(EventDayComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
