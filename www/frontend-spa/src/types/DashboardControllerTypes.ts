export interface State {
  userForm: {
    title: string;
    login: string;
    password: string;
    description: string;
    id: string;
  };
  validation_errors: { [key: string]: Array<string> };
  popup_visible: boolean;
  visible: Array<string>;
  popup_mode: string;
}
