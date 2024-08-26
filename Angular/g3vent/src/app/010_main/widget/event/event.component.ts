import { Component, Input } from '@angular/core';

@Component({
  selector: 'app-widget-event',
  templateUrl: './event.component.html',
  styleUrls: ['./event.component.scss'],
})
export class EventComponent {
  @Input() public event:Array<any> | any
}
