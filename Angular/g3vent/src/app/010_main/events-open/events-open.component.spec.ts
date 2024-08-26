import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EventsOpenComponent } from './events-open.component';

describe('EventsOpenComponent', () => {
  let component: EventsOpenComponent;
  let fixture: ComponentFixture<EventsOpenComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [EventsOpenComponent]
    });
    fixture = TestBed.createComponent(EventsOpenComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
