import { Component, Input } from '@angular/core';

@Component({
  selector: 'app-event-person',
  templateUrl: './event-person.component.html',
  styleUrls: ['./event-person.component.scss']
})
export class EventPersonComponent {
  @Input() public person:Array<any> | any
}
