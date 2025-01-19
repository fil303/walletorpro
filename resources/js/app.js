import './bootstrap';
import './siteProviderService';
import BindService from './BindService';

let bind = new BindService({},"bind");
bind.boot();