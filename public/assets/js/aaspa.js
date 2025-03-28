function isValidCPF(cpf) {
	cpf = cpf.replace(/\D/g, ""); // Remove non-numeric characters
	if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) {
		return false; // Invalid if not 11 digits or all digits are the same
	}

	let sum = 0, remainder;

	// Validate first digit
	for (let i = 1; i <= 9; i++) {
		sum += parseInt(cpf[i - 1]) * (11 - i);
	}
	remainder = (sum * 10) % 11;
	if (remainder === 10 || remainder === 11) remainder = 0;
	if (remainder !== parseInt(cpf[9])) return false;

	sum = 0;

	// Validate second digit
	for (let i = 1; i <= 10; i++) {
		sum += parseInt(cpf[i - 1]) * (12 - i);
	}
	remainder = (sum * 10) % 11;
	if (remainder === 10 || remainder === 11) remainder = 0;
	if (remainder !== parseInt(cpf[10])) return false;

	return true;
}