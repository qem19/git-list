# Git-list

All endpoints dont have any authorization. And all of it are used with base api endpoint - /api

Endpoint | Method | Parameters | Response |
--- | --- | --- | ---
/repositories | GET | - | All repositories ordered by vendor
/repositories/sync | POST | vendor (string) - required, repository (string) - required | Sync all commits to DB from received repository
/repositories/{repository} | GET | page (int) | Paginated list of commits selected repository
/commits | DELETE | commit_ids (int[]) - required | Delete received commits from DB    
