import { Component, Input } from '@angular/core';

@Component({
  selector: 'app-event-day',
  templateUrl: './event-day.component.html',
  styleUrls: ['./event-day.component.scss'],
})
export class EventDayComponent {
  @Input() public data: Array<any> | any;

  activeTab: string = 'tab1';

  selectTab(tab: string) {
    this.activeTab = tab;
  }
}
