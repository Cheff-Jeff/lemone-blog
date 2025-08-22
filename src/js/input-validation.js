export const validateEmail = (email) => {
  if (!email) return false;

  const emailRegex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  if (emailRegex.test(email)) {
    return true;
  }

  return false;
};
