declare namespace NodeJS {
	export interface ProcessEnv extends Dict<string> {
	  APP_NAME?: string;
	  APP_ENV?: string;
	  APP_KEY?: string;
	  APP_DEBUG?: string;
	  APP_URL?: string;
	  LOG_CHANNEL?: string;
	  LOG_DEPRECATIONS_CHANNEL?: string;
	  LOG_LEVEL?: string;
	  DB_CONNECTION?: string;
	  DB_HOST?: string;
	  DB_PORT?: string;
	  DB_DATABASE?: string;
	  DB_USERNAME?: string;
	  DB_PASSWORD?: string;
	  BROADCAST_DRIVER?: string;
	  CACHE_DRIVER?: string;
	  FILESYSTEM_DISK?: string;
	  QUEUE_CONNECTION?: string;
	  SESSION_DRIVER?: string;
	  SESSION_LIFETIME?: string;
	  MEMCACHED_HOST?: string;
	  REDIS_HOST?: string;
	  REDIS_PASSWORD?: string;
	  REDIS_PORT?: string;
	  MAIL_MAILER?: string;
	  MAIL_HOST?: string;
	  MAIL_PORT?: string;
	  MAIL_USERNAME?: string;
	  MAIL_PASSWORD?: string;
	  MAIL_ENCRYPTION?: string;
	  MAIL_FROM_ADDRESS?: string;
	  MAIL_FROM_NAME?: string;
	  AWS_ACCESS_KEY_ID?: string;
	  AWS_SECRET_ACCESS_KEY?: string;
	  AWS_DEFAULT_REGION?: string;
	  AWS_BUCKET?: string;
	  AWS_USE_PATH_STYLE_ENDPOINT?: string;
	  PUSHER_APP_ID?: string;
	  PUSHER_APP_KEY?: string;
	  PUSHER_APP_SECRET?: string;
	  PUSHER_HOST?: string;
	  PUSHER_PORT?: string;
	  PUSHER_SCHEME?: string;
	  PUSHER_APP_CLUSTER?: string;
	  VITE_PUSHER_APP_KEY?: string;
	  VITE_PUSHER_HOST?: string;
	  VITE_PUSHER_PORT?: string;
	  VITE_PUSHER_SCHEME?: string;
	  VITE_PUSHER_APP_CLUSTER?: string;
	}
}
