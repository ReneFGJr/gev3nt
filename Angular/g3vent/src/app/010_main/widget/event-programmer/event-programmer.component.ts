import { Component, Input } from '@angular/core';

@Component({
  selector: 'app-event-programmer',
  templateUrl: './event-programmer.component.html',
  styleUrls: ['./event-programmer.component.scss']
})
export class EventProgrammerComponent {
  @Input() public day:Array<any> | any
}
