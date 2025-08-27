import './styles/frontend.scss';
import { FrontendApp } from './components/FrontendApp';

// Initialize frontend app when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
  const frontendContainer = document.getElementById('plugin-frontend-app');
  if (frontendContainer) {
    new FrontendApp(frontendContainer);
  }
});
