import { Component } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Ge3ventServiceService } from 'src/app/000_service/ge3vent-service.service';

@Component({
  selector: 'app-user-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss'],
})
export class LoginComponent {
  phase: string = '0';
  inscricaoForm: FormGroup;
  cadastroForm: FormGroup;
  email: string = '';

  message: string = '';
  data: Array<any> | any;
  constructor(
    private fb: FormBuilder,
    private ge3ventServiceService: Ge3ventServiceService
  ) {
    this.inscricaoForm = this.fb.group({
      email: ['', [Validators.required, Validators.email]],
    });

    this.cadastroForm = this.fb.group({
      nome: ['', [Validators.required]],
      afiliacao: ['', [Validators.required]],
      cpf: [''],
      cracha_ufrgs: [''],
      orcid: [''],
    });

  }

  onSubmit() {
    if (this.inscricaoForm.valid) {
      console.log('Formulário Válido:', this.inscricaoForm.value);
      this.ge3ventServiceService
        .checkEmail(this.inscricaoForm.value.email)
        .subscribe((res) => {
          this.data = res;
          console.log(this.data);
          this.email = this.inscricaoForm.value.email;
          if (this.data['status'] == '200') {
            this.phase = '1';
          }
          if (this.data['status'] == '400') {
            this.phase = '2';
          }
        });
    } else {
      console.log('Formulário Inválido');
      alert('Por favor, corrija os erros no formulário.');
    }
  }
}
