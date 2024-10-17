import { Component } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Ge3ventServiceService } from 'src/app/000_service/ge3vent-service.service';

@Component({
  selector: 'app-form-email',
  templateUrl: './form-email.component.html',
  styleUrls: ['./form-email.component.scss'],
})
export class FormEmailComponent {
  emailForm: FormGroup;
  data: Array<any> | any;

  constructor(private fb: FormBuilder, private Ge3vent: Ge3ventServiceService) {
    this.emailForm = this.fb.group({
      email: ['', [Validators.required, Validators.email]],
    });
  }

  showCertificate(id:string='')
    {
      window.location.href = 'https://cip.brapci.inf.br/api/g3vent/certificate/'+id;
    }

  onSubmit() {
    if (this.emailForm.valid) {
      const email = this.emailForm.get('email')?.value;
      let endpoint = 'g3vent/certificateSearch';
      this.Ge3vent.api_post(endpoint, this.emailForm.value).subscribe((res) => {
        this.data = res;
        console.log(this.data);
      });
    }
  }
}
