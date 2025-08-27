export class FrontendApp {
  private container: HTMLElement;

  constructor(container: HTMLElement) {
    this.container = container;
    this.init();
  }

  private init(): void {
    this.render();
    this.bindEvents();
  }

  private render(): void {
    this.container.innerHTML = `
      <div class="plugin-frontend">
        <div class="plugin-frontend__container">
          <div class="plugin-frontend__header">
            <h1>Welcome to Our Plugin</h1>
            <p>Experience the power of modern WordPress development</p>
          </div>
          
          <div class="plugin-frontend__content">
            <div class="plugin-frontend__grid">
              <div class="plugin-frontend__card">
                <h3>Feature One</h3>
                <p>This is a description of the first amazing feature of our plugin.</p>
                <a href="#" class="plugin-frontend__button" data-action="feature1">Learn More</a>
              </div>
              
              <div class="plugin-frontend__card">
                <h3>Feature Two</h3>
                <p>Discover the second incredible feature that will enhance your experience.</p>
                <a href="#" class="plugin-frontend__button" data-action="feature2">Learn More</a>
              </div>
              
              <div class="plugin-frontend__card">
                <h3>Feature Three</h3>
                <p>Explore the third fantastic feature that completes the package.</p>
                <a href="#" class="plugin-frontend__button" data-action="feature3">Learn More</a>
              </div>
            </div>
          </div>
          
          <div class="plugin-frontend__footer">
            <p>&copy; 2024 Plugin Template. Built with modern WordPress development practices.</p>
          </div>
        </div>
      </div>
    `;
  }

  private bindEvents(): void {
    const buttons = this.container.querySelectorAll('[data-action]');
    buttons.forEach(button => {
      button.addEventListener('click', this.handleButtonClick.bind(this));
    });
  }

  private handleButtonClick(event: Event): void {
    event.preventDefault();
    
    const button = event.target as HTMLElement;
    const action = button.getAttribute('data-action');
    
    if (action) {
      this.handleAction(action);
    }
  }

  private handleAction(action: string): void {
    switch (action) {
      case 'feature1':
        this.showFeatureModal('Feature One', 'This is the detailed description of Feature One.');
        break;
      case 'feature2':
        this.showFeatureModal('Feature Two', 'This is the detailed description of Feature Two.');
        break;
      case 'feature3':
        this.showFeatureModal('Feature Three', 'This is the detailed description of Feature Three.');
        break;
      default:
        console.log('Unknown action:', action);
    }
  }

  private showFeatureModal(title: string, content: string): void {
    // Create modal overlay
    const overlay = document.createElement('div');
    overlay.style.cssText = `
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 1000;
    `;

    // Create modal content
    const modal = document.createElement('div');
    modal.style.cssText = `
      background: white;
      padding: 2rem;
      border-radius: 8px;
      max-width: 500px;
      width: 90%;
      position: relative;
    `;

    modal.innerHTML = `
      <h2 style="margin-top: 0; color: #0073aa;">${title}</h2>
      <p>${content}</p>
      <button class="plugin-frontend__button" style="margin-top: 1rem;">Close</button>
    `;

    overlay.appendChild(modal);
    document.body.appendChild(overlay);

    // Handle close
    const closeButton = modal.querySelector('button');
    if (closeButton) {
      closeButton.addEventListener('click', () => {
        document.body.removeChild(overlay);
      });
    }

    // Close on overlay click
    overlay.addEventListener('click', (event) => {
      if (event.target === overlay) {
        document.body.removeChild(overlay);
      }
    });
  }
}
