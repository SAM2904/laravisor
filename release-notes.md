# Laravisor v1.0.0

Laravisor v1.0.0 is the first stable release focused on **developer-first error monitoring** with zero friction and maximum safety.

---

## 🚀 Highlights

- No API key required to start receiving error emails
- Central dashboard is completely optional
- Designed to never break host applications
- Laravel-native implementation

---

## ✨ What’s Included

### Client Package
- Automatic exception capturing
- Instant email notifications
- Environment-based reporting
- Exception ignore list
- Optional local database storage
- Fully wrapped in try/catch for safety
- Queue, cron, and scheduler safe

### Laravisor Server (Optional)
- Central error ingestion API
- Error grouping using fingerprints
- Error list and detail dashboard
- Stack trace viewer
- Recent occurrence tracking
- Resolve / Ignore workflow
- Project-based isolation

---

## 🧠 Developer Experience Improvements

- Keyless onboarding (emails work immediately)
- No dependency on Laravisor Server availability
- Progressive adoption model
- Clean and extensible payload structure

---

## 🛡 Stability Guarantees

- Notification failures are silently ignored
- Network failures never affect requests
- Storage failures do not break execution
- Safe for production use

---

## ✅ Recommended Usage

1. Install Laravisor and enable email notifications
2. Use keyless mode during development and staging
3. Enable local storage if required
4. Add Laravisor Server when centralized monitoring is needed

---

## 📄 License

MIT License © Laravisor