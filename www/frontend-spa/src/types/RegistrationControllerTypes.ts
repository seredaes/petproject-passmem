export interface State {
  userForm: {
    email: string;
    password: string;
    password_confirmation: string;
    name: string;
  };
  validation_errors: { [key: string]: Array<string> };
}
