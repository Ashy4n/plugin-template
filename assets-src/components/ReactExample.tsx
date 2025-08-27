import React, { useState, useEffect } from 'react';

interface PluginSettings {
  setting1: string;
  setting2: string;
  setting3: string;
}

interface ReactExampleProps {
  initialSettings?: PluginSettings;
  onSave?: (settings: PluginSettings) => void;
}

export const ReactExample: React.FC<ReactExampleProps> = ({
  initialSettings = { setting1: '', setting2: '', setting3: '' },
  onSave
}) => {
  const [settings, setSettings] = useState<PluginSettings>(initialSettings);
  const [isLoading, setIsLoading] = useState(false);
  const [message, setMessage] = useState<{ type: 'success' | 'error'; text: string } | null>(null);

  const handleInputChange = (field: keyof PluginSettings, value: string) => {
    setSettings(prev => ({
      ...prev,
      [field]: value
    }));
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setIsLoading(true);
    setMessage(null);

    try {
      if (onSave) {
        await onSave(settings);
      }
      
      // Simulate API call
      await new Promise(resolve => setTimeout(resolve, 1000));
      
      setMessage({
        type: 'success',
        text: 'Settings saved successfully!'
      });
    } catch (error) {
      setMessage({
        type: 'error',
        text: 'Error saving settings. Please try again.'
      });
    } finally {
      setIsLoading(false);
    }
  };

  useEffect(() => {
    if (message) {
      const timer = setTimeout(() => {
        setMessage(null);
      }, 5000);
      
      return () => clearTimeout(timer);
    }
  }, [message]);

  return (
    <div className="react-example">
      <h2>React Component Example</h2>
      
      {message && (
        <div className={`message message--${message.type}`}>
          {message.text}
        </div>
      )}
      
      <form onSubmit={handleSubmit} className="settings-form">
        <div className="form-group">
          <label htmlFor="setting1">Setting 1</label>
          <input
            type="text"
            id="setting1"
            value={settings.setting1}
            onChange={(e) => handleInputChange('setting1', e.target.value)}
            disabled={isLoading}
          />
        </div>
        
        <div className="form-group">
          <label htmlFor="setting2">Setting 2</label>
          <select
            id="setting2"
            value={settings.setting2}
            onChange={(e) => handleInputChange('setting2', e.target.value)}
            disabled={isLoading}
          >
            <option value="">Select an option</option>
            <option value="option1">Option 1</option>
            <option value="option2">Option 2</option>
            <option value="option3">Option 3</option>
          </select>
        </div>
        
        <div className="form-group">
          <label htmlFor="setting3">Setting 3</label>
          <textarea
            id="setting3"
            value={settings.setting3}
            onChange={(e) => handleInputChange('setting3', e.target.value)}
            rows={4}
            disabled={isLoading}
          />
        </div>
        
        <button 
          type="submit" 
          className="btn btn--primary"
          disabled={isLoading}
        >
          {isLoading ? 'Saving...' : 'Save Settings'}
        </button>
      </form>
    </div>
  );
};
