export interface State {
  userForm: {
    email: string;
    password: string;
  };
  validation_errors: { [key: string]: Array<string> };
}