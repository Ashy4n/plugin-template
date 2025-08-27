import './styles/admin.scss';
import { AdminApp } from './components/AdminApp';

// Initialize admin app when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
  const adminContainer = document.getElementById('plugin-admin-app');
  if (adminContainer) {
    new AdminApp(adminContainer);
  }
});
