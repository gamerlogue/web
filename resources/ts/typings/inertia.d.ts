export interface PageComponentProps {
  user: App.Models.User;
  flash: {
    status: string | null;
    status_multiline: boolean | null;
    status_persistent: boolean | null;
  };
  [key: string]: unknown;
}
