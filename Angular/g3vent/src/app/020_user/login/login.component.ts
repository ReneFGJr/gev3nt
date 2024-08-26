import { Component } from '@angular/core';
import {
  AbstractControl,
  FormBuilder,
  FormGroup,
  ValidatorFn,
  Validators,
} from '@angular/forms';
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

  valida_nome_message = '';
  message_global = '';

  validaCadastro() {
    let validate: Boolean = true
    let nome = this.cadastroForm.value['nome'];
    if (!this.fullNameValidator(nome))
        {
          this.valida_nome_message =
          'Não pode ser inserido pontuação ou abreviações';
          validate = false
        } else {
          this.valida_nome_message = '';
        }
      /******************************* */
      if (!this.cadastroForm.valid)
        {
          validate = false;
        }

      return validate;
  }

  fullNameValidator(value: string): boolean {
    if (!value) return false;

    // Remover espaços extras e dividir o nome em palavras
    const words = value.trim().split(/\s+/);

    // Verifica se há pelo menos duas palavras
    if (words.length < 2) {
      return false;
    }

    // Verifica se há caracteres especiais proibidos
    const hasInvalidChars = /[.,/#!$%^&*;:{}=\-_`~()]/.test(value);
    if (hasInvalidChars) {
      return false;
    }

    // Verifica se cada palavra tem mais de 2 caracteres (para evitar abreviações)
    const hasAbbreviation = words.some((word) => word.length <= 2);

    // O nome é válido se houver pelo menos duas palavras, nenhuma abreviação, e nenhum caractere inválido
    return !hasAbbreviation && !hasInvalidChars;
  }

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

  onRegister()
    {
        if (this.validaCadastro() && this.cadastroForm.valid) {
          console.log('OK');
          alert("OK")
        } else {
          console.log('ERRO');
          this.message_global = 'Campos obrigatórios não preenchidos.';
        }


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
            this.ge3ventServiceService.set("g3vent",this.data)
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
