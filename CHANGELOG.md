# Changelog

All notable changes to `unifi-access-api` will be documented in this file

## 1.1.1 - 2025-10-23

**Breaking:**
- Renamed `VisitorRequest` to ``UpsertVisitorRequest`

**New features:**
- The 'all visitors' request now accepts params for filters and pagination


## 1.1.0 - 2025-10-23

**Breaking:**
- All entities moved to entity-specific namespace

**New features:**

- Add 'system' client and method to retrieve logs by @maarten00 in #2
- Implement Composer cache in Github Actions by @maarten00 in #3


## 1.0.1 - 2025-10-19

- Pass Guzzle options to get and download function


## 1.0.0 - 2025-10-18

First version that includes all resources required to 
- retrieve doors
- create a visitor
- assign a QR code
- download a visitor QR code.
