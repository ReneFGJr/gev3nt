import { TestBed } from '@angular/core/testing';

import { Ge3ventServiceService } from './ge3vent-service.service';

describe('Ge3ventServiceService', () => {
  let service: Ge3ventServiceService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(Ge3ventServiceService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
