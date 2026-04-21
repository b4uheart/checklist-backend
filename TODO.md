# QR Code Feature Implementation Plan

## Steps:
- [x] Step 1: Update application/views/dashboard/equipment.php\n  - Add QR modal HTML\n  - Add qrcode.js CDN script\n  - Change QR buttons to data-qr/data-name buttons\n  - Add JS event listeners for show QR, generate QR canvas, print\n  - Add print CSS
- [ ] Step 2: Test functionality
  - Add equipment with qr_code
  - Click QR button → modal opens with QR image
  - Verify QR scans to qr_code
  - Print QR
- [ ] Step 3: Optional API enhancement for server-side QR image

**Current Progress:** Starting Step 1
