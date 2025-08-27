export class AdminApp {
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
      <div class="plugin-admin">
        <div class="plugin-admin__header">
          <h1>Plugin Admin Dashboard</h1>
        </div>
        <div class="plugin-admin__content">
          <form class="plugin-admin__form" id="plugin-admin-form">
            <div class="form-group">
              <label for="plugin-setting">Plugin Setting</label>
              <input type="text" id="plugin-setting" name="plugin_setting" value="">
            </div>
            <div class="form-group">
              <label for="plugin-option">Plugin Option</label>
              <select id="plugin-option" name="plugin_option">
                <option value="">Select an option</option>
                <option value="option1">Option 1</option>
                <option value="option2">Option 2</option>
                <option value="option3">Option 3</option>
              </select>
            </div>
            <button type="submit" class="btn btn--primary">Save Settings</button>
          </form>
          <div id="admin-notices"></div>
        </div>
      </div>
    `;
  }

  private bindEvents(): void {
    const form = this.container.querySelector('#plugin-admin-form') as HTMLFormElement;
    if (form) {
      form.addEventListener('submit', this.handleFormSubmit.bind(this));
    }
  }

  private async handleFormSubmit(event: Event): Promise<void> {
    event.preventDefault();
    
    const form = event.target as HTMLFormElement;
    const formData = new FormData(form);
    
    try {
      // Simulate API call
      await this.saveSettings(formData);
      this.showNotice('Settings saved successfully!', 'success');
    } catch (error) {
      this.showNotice('Error saving settings. Please try again.', 'error');
    }
  }

  private async saveSettings(formData: FormData): Promise<void> {
    // Simulate API call delay
    await new Promise(resolve => setTimeout(resolve, 1000));
    
    // In a real implementation, this would make an AJAX call to WordPress
    console.log('Saving settings:', Object.fromEntries(formData));
  }

  private showNotice(message: string, type: 'success' | 'warning' | 'error'): void {
    const noticesContainer = this.container.querySelector('#admin-notices');
    if (noticesContainer) {
      const notice = document.createElement('div');
      notice.className = `plugin-admin__notice plugin-admin__notice--${type}`;
      notice.textContent = message;
      
      noticesContainer.appendChild(notice);
      
      // Auto-remove notice after 5 seconds
      setTimeout(() => {
        notice.remove();
      }, 5000);
    }
  }
}
